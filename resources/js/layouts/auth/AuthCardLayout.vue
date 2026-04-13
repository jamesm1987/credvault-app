<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Shield } from 'lucide-vue-next';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { dashboard } from '@/routes';

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <div
        class="flex min-h-screen flex-col items-center justify-center bg-background p-4"
    >
    <div class="w-full max-w-md rounded-lg shadow-sm">
        <Card class="group/card flex flex-col gap-6 overflow-hidden rounded-4xl py-6 text-sm text-card-foreground shadow-md ring-1 ring-foreground/5 has-[>img:first-child]:pt-0 data-[size=sm]:gap-4 data-[size=sm]:py-4 dark:ring-foreground/10 *:[img:first-child]:rounded-t-4xl *:[img:last-child]:rounded-b-4xl w-full max-w-md border-border/50 bg-card/80 backdrop-blur-sm">
            <CardHeader class="text-center space-y-4">

                <div class="mx-auto w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center">
                    <Shield class="w-6 h-6 text-primary" />
                </div>
                
                <CardTitle class="text-2xl">{{ title }}</CardTitle>
                <CardDescription class="mt-1">
                    {{ description }}
                </CardDescription>
            </CardHeader>
            <CardContent>
                <slot />
            </CardContent>
        </Card>
    </div>
    </div>
</template>
