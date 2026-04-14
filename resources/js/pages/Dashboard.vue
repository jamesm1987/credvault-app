<script setup lang="ts">
import { Head, useForm, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { dashboard } from '@/routes';
import { Search, Trash2, Globe, Plus } from "lucide-vue-next";
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from "@/Components/ui/dialog";


const props = defineProps<{
    clients: Array<{
        id: number;
        name: string;
        created_at: string;
    }>;
    filters: {
        search: string;
    }
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Dashboard',
                href: dashboard(),
            },
        ],
    },
});


const search = ref(props.filters?.search || '');
watch(search, (value) => {
    router.get('/dashboard', { search: value }, {
        preserveState: true,
        replace: true
    });
});

const form = useForm({
    name: '',
});

const submit = () => {
    form.post('/clients', {
        onSuccess: () => {
            form.reset();
        },
    });
};

const deleteClient = (id: number) => {
    if (confirm('Are you sure you want to delete this client?')) {
        router.delete(`/clients/${id}`);
    }
};


</script>

<template>
    <Head title="Dashboard" />

    <div class="w-full max-w-7xl px-2 py-4 space-y-4">
        <div class="flex items-center justify-between gap-4">
            
            <div class="relative max-w-sm w-full">
                <Search class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-white/70" />
                <Input
                    name="client"
                    placeholder="Search clients..."
                    class="h-12 w-full rounded-full pl-12 text-lg bg-transparent border-2 border-zinc-700 focus-visible:border-white focus-visible:ring-0 focus-visible:ring-offset-0 transition-colors" 
                    v-model="search"
                />
            </div>

            <Dialog>
                <DialogTrigger asChild>
                    <Button>
                        <Plus class="w-4 h-4 mr-2" />
                        Add Client
                    </Button>
                </DialogTrigger>
                <DialogContent>
                    <DialogHeader>
                        <DialogTitle>New Client</DialogTitle>
                    </DialogHeader>
                    <form @submit.prevent="submit" class="space-y-4">
                        <div class="space-y-2">
                            <Label for="name">Name *</Label>
                            <Input 
                                id="name" 
                                v-model="form.name" 
                                name="name" 
                                required 
                                placeholder="Client name" 
                                :disabled="form.processing" 
                            />

                            <div v-if="form.errors.name" class="text-destructive text-sm">
                                {{ form.errors.name }}
                            </div>
                        </div>
                        <Button type="submit" class="w-full" :disabled="form.processing">
                            {{ form.processing ? 'Creating...' : 'Create Client' }}
                        </Button>
                    </form>
                </DialogContent>
            </Dialog>
        </div> 

        <div class="rounded-md border border-border overflow-hidden">
            <Table>
                <TableHeader>
                    <TableRow class="hover:bg-transparent">
                        <TableHead>Name</TableHead>
                        <TableHead>Website</TableHead>
                        <TableHead>Notes</TableHead>
                        <TableHead>Created</TableHead>
                        <TableHead class="w-[60px]"></TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <template v-if="clients?.length > 0">
                        <TableRow v-for="client in clients" :key="client.id" class="hover:bg-muted/50 cursor-pointer">
                            <TableCell class="font-medium">{{ client.name }}</TableCell>
                            <TableCell>
                                <span class="text-muted-foreground/50 text-xs">—</span>
                            </TableCell>
                            <TableCell>
                                <span class="text-muted-foreground text-sm line-clamp-1 max-w-[250px]">
                                    <span class="text-muted-foreground/50">—</span>
                                </span>
                            </TableCell>
                            <TableCell>
                                <span class="text-sm">Just now</span>
                            </TableCell>
                            <TableCell>
                                <Button
                                    variant="ghost"
                                    size="icon"
                                    class="h-7 w-7"
                                >
                                    <Trash2 class="w-3.5 h-3.5 text-destructive" />
                                </Button>
                            </TableCell>
                        </TableRow>
                    </template>

                    <TableRow v-else>
                        <TableCell colSpan="5" class="text-center py-10 text-muted-foreground">
                            No clients found.
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>
    </div>
</template>